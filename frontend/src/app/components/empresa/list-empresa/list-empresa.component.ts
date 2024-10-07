import { Component, EventEmitter, inject, model, Output, signal } from '@angular/core';
import { EmpresaService } from '../../../services/empresa.service';
import { Empresa } from '../../../interfaces/empresa.interface';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { CustomDialogSevice } from '../../dialog/custom-dialog/custom-dialog.service';

@Component({
  selector: 'app-list-empresa',
  standalone: true,
  imports: [ MatTableModule, MatButtonModule, MatIconModule ],
  templateUrl: './list-empresa.component.html',
  styleUrl: './list-empresa.component.css'
})
export class ListEmpresaComponent {
	empresas: Empresa[] = [];
	columns: string[] = [ "nome", "cnpj", "dataFundacao", "acoes" ];

	service = inject(EmpresaService);
	router = inject(Router);
	dialog = inject(CustomDialogSevice);
	snackBar = inject(MatSnackBar);

	ngOnInit() {
		this._loadEmpresas();
	}

	onEdit(empresa: Empresa) {
		this.router.navigateByUrl(`/editar-empresa/${empresa.id}`)
	}

	onApagar(empresa: Empresa) {
		this.dialog.onOpen().subscribe(confirm => {
			if (!confirm) {
				return;
			}
			this._apagar(empresa.id);
		});
	}

	private _loadEmpresas() {
		this.service.getAll().subscribe(resp => this.empresas = resp.data);
	}

	private _apagar(id: number) {
		this.service.apagar(id).subscribe(response => {
			this.snackBar.open(response.message, "Fechar", {
				duration: 3000,
				verticalPosition: "top",
				horizontalPosition: "end"
			});
			this._loadEmpresas();
		});
	}
}