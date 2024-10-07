import { Component, inject, Inject } from '@angular/core';
import { Socio } from '../../../interfaces/socio.interfaces';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { SocioService } from '../../../services/socio.service';
import { Router } from '@angular/router';
import { CustomDialogService } from '../../dialog/custom-dialog/custom-dialog.service';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-lista-socio',
  standalone: true,
  imports: [ MatTableModule, MatButtonModule, MatIconModule ],
  templateUrl: './lista-socio.component.html',
  styleUrl: './lista-socio.component.css'
})
export class ListaSocioComponent {

	socios: Array<Socio> = [];
	columns: string[] = [ "empresa", "nome", "cpf", "dataVinculo", "acoes" ];
	service = inject(SocioService);
	router = inject(Router);
	dialogService = inject(CustomDialogService);
	snackBar = inject(MatSnackBar);

	ngOnInit() {
		this._loadEmpresas();
	}

	onEdit(socio: Socio) {
		this.router.navigateByUrl(`/editar-socio/${socio.id}`)
	}

	onApagar(socio: Socio) {
		console.log(socio);
		this.dialogService
			.onOpen({
				title: `${socio.nome}: ${socio.cpf_mascara}`,
			}).subscribe(confirm => {
				this._apagar(socio.id);
			});
	}
	private _loadEmpresas() {
		this.service.getAll().subscribe(resp => this.socios = resp.data);
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
