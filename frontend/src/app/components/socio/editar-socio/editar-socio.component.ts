import { Component, inject } from '@angular/core';
import { FormSocioComponent } from "../form-socio/form-socio.component";
import { PayloadSocio, ResponseSocio, Socio } from '../../../interfaces/socio.interfaces';
import { SocioService } from '../../../services/socio.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-editar-socio',
  standalone: true,
  imports: [ FormSocioComponent],
  templateUrl: './editar-socio.component.html',
  styleUrl: './editar-socio.component.css'
})
export class EditarSocioComponent {

	service = inject(SocioService);
	snackBar = inject(MatSnackBar);
	router = inject(Router);
	
	socioResp: ResponseSocio = inject(ActivatedRoute).snapshot.data['socio'];
	socio: Socio = this.socioResp.data; 

	onSalvar(socio: PayloadSocio) {
		this.service.salvar(socio).subscribe(resp => {
			this.snackBar.open(resp.message, "Fechar", {
				duration: 3000,
				verticalPosition: "top",
				horizontalPosition: "end"
			});
			this.router.navigateByUrl("/socios");
		});
	}
}
