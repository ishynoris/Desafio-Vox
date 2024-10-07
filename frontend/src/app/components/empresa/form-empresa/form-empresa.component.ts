import { Component, EventEmitter, inject, input, InputSignal, Output } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { Empresa, PayloadEmpresa } from '../../../interfaces/empresa.interface';
import { Router } from '@angular/router';

@Component({
  selector: 'app-form-empresa',
  standalone: true,
  imports: [
	ReactiveFormsModule, 
	MatFormFieldModule, 
	MatInputModule, 
	MatDatepickerModule, 
	MatButtonModule 
  ],
  templateUrl: './form-empresa.component.html',
  styleUrl: './form-empresa.component.css'
})
export class FormEmpresaComponent {

	form!: FormGroup;
	empresa!: Empresa | undefined;
	empresaSignal: InputSignal<Empresa | undefined> = input<Empresa | undefined>();
	router = inject(Router);

	@Output() eventConfirmacao = new EventEmitter<PayloadEmpresa>();

	ngOnInit() {
		this.empresa = this.empresaSignal();

		this.form = new FormGroup({
			nome: new FormControl<string>(this.empresa?.nome || "", {
				nonNullable: true,
				validators: Validators.required,
			}),
			cnpj: new FormControl<string>(this.empresa?.cnpj_mascara || "", {
				nonNullable: true,
				validators: Validators.required,
			}),
			dataFundacao: new FormControl<string>(this._getDataFundacao())
		})
	}

	onVoltar() {
		this.router.navigateByUrl("");
	}

	onConfirm() {
		const payload = {
			nome: this.form.controls['nome'].value,
			cnpj: this.form.controls['cnpj'].value,
			data_fundacao: this.form.controls['dataFundacao'].value
		} as PayloadEmpresa;
		this.eventConfirmacao.emit(payload)
	}

	private _getDataFundacao(): string {
		if (this.empresa == null) {
			return "";
		}
		return new Date(this.empresa.data_atualizacao_ptbr).toISOString();
	}
}
