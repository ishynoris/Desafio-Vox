import { HttpClient } from '@angular/common/http';
import { Component, EventEmitter, inject, model, Output, signal } from '@angular/core';
import { EmpresaService } from '../../../services/empresa.service';
import { Empresa } from '../../../interfaces/empresa.interface';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { Router } from '@angular/router';
import { MAT_DIALOG_DATA, MatDialog, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatSnackBar } from '@angular/material/snack-bar';

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
	dialog = inject(MatDialog);
	snackBar = inject(MatSnackBar);

	ngOnInit() {
		this._loadEmpresas();
	}

	onEdit(empresa: Empresa) {
		this.router.navigateByUrl(`/editar-empresa/${empresa.id}`)
	}

	onApagar(empresa: Empresa) {
		const selfDialog = this.dialog.open(ApagarEmpresaComponent, { 
			data: empresa,
			width: "500px",
			panelClass: 'xpto'
		});
		
		selfDialog.afterClosed().subscribe(apagar => {
			if (!apagar) {
				return;
			}

			this.service.apagar(empresa.id).subscribe(resp => {
				this.snackBar.open(resp.message, "Fechar", {
					duration: 3000,
					verticalPosition: "top",
					horizontalPosition: "end"
				});
				this._loadEmpresas();
			});
		});
	}

	private _loadEmpresas() {
		this.service.getAll().subscribe(resp => this.empresas = resp.data);
	}
}


@Component({
	selector: 'app-apagar-empresa',
	standalone: true,
	imports: [ MatDialogModule, MatFormFieldModule, MatButtonModule ],
	template: `
		<h2 mat-dialog-title>Confirmação</h2>
		<mat-dialog-content>
			<p>Deseja realmente apagar {{ this.empresa.nome}}</p>
		</mat-dialog-content>
		<mat-dialog-actions>
			<button mat-button (click)="onNao()">Não</button>
			<button mat-button (click)="onSim()" cdkFocusInitial>Sim</button>
		</mat-dialog-actions>
	`
})
export class ApagarEmpresaComponent {
	readonly dialogRef = inject(MatDialogRef<ApagarEmpresaComponent, boolean>);
	readonly data = inject<Empresa>(MAT_DIALOG_DATA);
	readonly empresa = this.data;
	
	onSim() {
		this.dialogRef.close(true);
	}

	onNao() {
		this.dialogRef.close(false);
	}
}