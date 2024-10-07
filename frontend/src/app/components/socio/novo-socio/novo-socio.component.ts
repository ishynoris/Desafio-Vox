import { Component, inject } from '@angular/core';
import { FormSocioComponent } from "../form-socio/form-socio.component";
import { PayloadSocio } from '../../../interfaces/socio.interfaces';
import { SocioService } from '../../../services/socio.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';

@Component({
  selector: 'app-novo-socio',
  standalone: true,
  imports: [ FormSocioComponent],
  templateUrl: './novo-socio.component.html',
  styleUrl: './novo-socio.component.css'
})
export class NovoSocioComponent {

	service = inject(SocioService);
	snackBar = inject(MatSnackBar);
	router = inject(Router);

	onSalvar(socio: PayloadSocio) {
		this.service.salvar(socio).subscribe(resp => {
			this.snackBar.open(resp.message, "Fechar", {
				duration: 3000,
				verticalPosition: "top",
				horizontalPosition: "end"
			});
			this.router.navigateByUrl("/socios");
		});
	}
}
