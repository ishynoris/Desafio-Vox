import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { EmpresaService } from '../../../services/empresa.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ActivatedRoute } from '@angular/router';
import { Empresa, PayloadEmpresa } from '../../../interfaces/empresa.interface';
import { EmpresaResponse } from '../../../interfaces/empresa_response.interface';
import { FormEmpresaComponent } from "../form-empresa/form-empresa.component";

@Component({
  selector: 'app-editar-empresa',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatDatepickerModule,
    MatButtonModule,
    FormEmpresaComponent
],
  templateUrl: './editar-empresa.component.html',
  styleUrl: './editar-empresa.component.css'
})
export class EditarEmpresaComponent {
	service = inject(EmpresaService);
	snackBar = inject(MatSnackBar);

	empresaResp: EmpresaResponse = inject(ActivatedRoute).snapshot.data['empresa'];
	empresa: Empresa = this.empresaResp.data; 

	form = new FormGroup({
		nome: new FormControl<string>(this.empresa.nome, {
			nonNullable: true,
			validators: Validators.required,
		}),
		cnpj: new FormControl<string>(this.empresa.cnpj_mascara, {
			nonNullable: true,
			validators: Validators.required,
		}),
		dataFundacao: new FormControl<string>(
			new Date(this.empresa.data_fundacao_ptbr).toISOString()
		)
	})

	onAtualizar(payload: PayloadEmpresa) {
		const id = this.empresa.id;
		this.service.atualizar(id, payload).subscribe(resp => {
			this.snackBar.open(resp.message, "Fechar", {
				duration: 3000,
				verticalPosition: "top",
				horizontalPosition: "end"
			});
		});
	}
}
