import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { EmpresaService } from '../../../services/empresa.service';
import { Empresa } from '../../../interfaces/empresa.interface';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-list-empresa',
  standalone: true,
  imports: [MatTableModule, MatButtonModule],
  templateUrl: './list-empresa.component.html',
  styleUrl: './list-empresa.component.css'
})
export class ListEmpresaComponent {
	empresas: Empresa[] = [];
	columns: string[] = [];

	service = inject(EmpresaService)

	ngOnInit() {
		this.service.getAll().subscribe(resp => {
			this.empresas = resp.data;
			this.columns = [ "nome", "cnpj", "dataFundacao" ];
		})
	}

	addEmpresa() {

	}
}
