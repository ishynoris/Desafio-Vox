import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { Empresa } from '../../../interfaces/empresa.interface';
import { EmpresaService } from '../../../services/empresa.service';

@Component({
  selector: 'app-nova-empresa',
  standalone: true,
  imports: [ 
	ReactiveFormsModule, 
	MatFormFieldModule, 
	MatInputModule, 
	MatDatepickerModule, 
	MatButtonModule 
  ],
  templateUrl: './nova-empresa.component.html',
  styleUrl: './nova-empresa.component.css'
})
export class NovaEmpresaComponent {
	service = inject(EmpresaService);

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

	onSalvar() {
		this.service.salvar({
			nome: this.form.controls.nome.value,
			cnpj: this.form.controls.cnpj.value,
			data_fundacao: this.form.controls.dataFundacao.value
		}).subscribe(resp => console.log);
	}
}
