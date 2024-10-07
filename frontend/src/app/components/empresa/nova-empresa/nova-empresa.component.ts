import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { EmpresaService } from '../../../services/empresa.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { FormEmpresaComponent } from "../form-empresa/form-empresa.component";
import { PayloadEmpresa } from '../../../interfaces/empresa.interface';

@Component({
  selector: 'app-nova-empresa',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatDatepickerModule,
    MatButtonModule,
    FormEmpresaComponent
],
  templateUrl: './nova-empresa.component.html',
  styleUrl: './nova-empresa.component.css'
})
export class NovaEmpresaComponent {
	service = inject(EmpresaService);
	snackBar = inject(MatSnackBar);
	router = inject(Router);

	form = new FormGroup({
		nome: new FormControl<string>("", {
			nonNullable: true,
			validators: Validators.required,
		}),
		cnpj: new FormControl<string>("", {
			nonNullable: true,
			validators: Validators.required,
		}),
		dataFundacao: new FormControl<string>("")
	})

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
