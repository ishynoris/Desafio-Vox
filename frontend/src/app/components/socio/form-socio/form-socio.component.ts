import { Component, EventEmitter, inject, Input, input, InputSignal, Output } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { Router } from '@angular/router';
import { PayloadSocio, Socio } from '../../../interfaces/socio.interfaces';
import { MatSelectModule } from '@angular/material/select';
import { EmpresaService } from '../../../services/empresa.service';
import { Empresa } from '../../../interfaces/empresa.interface';
import { MatOptionModule } from '@angular/material/core';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-form-socio',
  standalone: true,
  imports: [
	ReactiveFormsModule, 
	MatFormFieldModule, 
	MatInputModule, 
	MatSelectModule,
	MatOptionModule,
	MatDatepickerModule, 
	MatButtonModule,
	NgFor 
  ],
  templateUrl: './form-socio.component.html',
  styleUrl: './form-socio.component.css'
})
export class FormSocioComponent {

	@Output() eventConfirmacao = new EventEmitter<PayloadSocio>();

	empresas: Array<Empresa> = [];
	selectEmpresa: number = 0;

	router = inject(Router);
	empresaService = inject(EmpresaService);
	socioSig = input<Socio | undefined>();

	socio!: Socio | undefined;
	form!: FormGroup;

	ngOnInit() {
		this._loadEmpresas();

		this.socio = this.socioSig();
		this.form = new FormGroup({
			idEmpresa: new FormControl<string>(this.socio?.empresa.nome || "", {
				nonNullable: true,
				validators: Validators.required,
			}),
			nome: new FormControl<string>(this.socio?.nome || "", {
				nonNullable: true,
				validators: Validators.required,
			}),
			cpf: new FormControl<string>(this.socio?.cpf_mascara || "", {
				nonNullable: true,
				validators: Validators.required,
			}),
			dataVinculo: new FormControl<string>(this._getDataFundacao()),
		})
	}

	onVoltar() {
		this.router.navigateByUrl("");
	}

	onConfirm() {
		const controls = this.form.controls;
		this.eventConfirmacao.emit({
			empresa_id: this.selectEmpresa,
			nome: controls["nome"].value,
			cpf: controls["cpf"].value,
			data_vinculo: controls["dataVinculo"].value,
		})
	}

	private _loadEmpresas() {
		this.empresaService.getAll().subscribe(resp => {
			this.empresas = resp.data;
		});
	}

	private _getDataFundacao(): string {
		if (this.socio == null) {
			return "";
		}
		return new Date(this.socio.data_vinculo_ptbr).toISOString();
	}
}
