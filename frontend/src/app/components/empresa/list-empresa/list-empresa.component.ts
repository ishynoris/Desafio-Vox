import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { EmpresaService } from '../../../services/empresa.service';
import { Empresa } from '../../../interfaces/empresa.interface';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { Router } from '@angular/router';

@Component({
  selector: 'app-list-empresa',
  standalone: true,
  imports: [ MatTableModule, MatButtonModule, MatIconModule ],
  templateUrl: './list-empresa.component.html',
  styleUrl: './list-empresa.component.css'
})
export class ListEmpresaComponent {
	empresas: Empresa[] = [];
	columns: string[] = [];

	service = inject(EmpresaService);
	router = inject(Router);

	ngOnInit() {
		this.service.getAll().subscribe(resp => {
			this.empresas = resp.data;
			this.columns = [ "nome", "cnpj", "dataFundacao", "acoes" ];
		})
	}

	onEdit(empresa: Empresa) {
		this.router.navigateByUrl(`/editar-empresa/${empresa.id}`)
	}

	onApagar(empresa: Empresa) {
		console.log(`/empresa/${empresa.id}`)
	}
}
