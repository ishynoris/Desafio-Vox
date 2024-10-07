import { Component, inject } from '@angular/core';
import { EmpresaService } from '../../../services/empresa.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { FormEmpresaComponent } from "../form-empresa/form-empresa.component";
import { PayloadEmpresa } from '../../../interfaces/empresa.interface';

@Component({
  selector: 'app-nova-empresa',
  standalone: true,
  imports: [ FormEmpresaComponent ],
  templateUrl: './nova-empresa.component.html',
  styleUrl: './nova-empresa.component.css'
})
export class NovaEmpresaComponent {
	service = inject(EmpresaService);
	snackBar = inject(MatSnackBar);
	router = inject(Router);

	onSalvar(payload: PayloadEmpresa) {
		this.service.salvar(payload).subscribe(resp => {
			this.snackBar.open(resp.message, "Fechar", {
				duration: 3000,
				verticalPosition: "top",
				horizontalPosition: "end"
			});
			this.router.navigateByUrl("/");
		});
	}
}
