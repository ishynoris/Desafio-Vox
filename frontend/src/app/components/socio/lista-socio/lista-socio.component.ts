import { Component, inject, Inject } from '@angular/core';
import { Socio } from '../../../interfaces/socio.interfaces';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { SocioService } from '../../../services/socio.service';
import { Router } from '@angular/router';

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

	ngOnInit() {
		this._loadEmpresas();
	}

	onEdit(socio: Socio) {
		this.router.navigateByUrl(`/editar-socio/${socio.id}`)
	}

	onApagar(socio: Socio) {

	}
	private _loadEmpresas() {
		this.service.getAll().subscribe(resp => this.socios = resp.data);
	}
}
