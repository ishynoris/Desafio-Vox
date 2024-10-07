import { ActivatedRouteSnapshot, RedirectCommand, RouterStateSnapshot, Routes } from '@angular/router';
import { ListEmpresaComponent } from './components/empresa/list-empresa/list-empresa.component';
import { NovaEmpresaComponent } from './components/empresa/nova-empresa/nova-empresa.component';
import { inject } from '@angular/core';
import { EmpresaService } from './services/empresa.service';
import { EditarEmpresaComponent } from './components/empresa/editar-empresa/editar-empresa.component';
import { EmpresaResponse } from './interfaces/empresa_response.interface';
import { Observable } from 'rxjs';

const ResolverEmpresa = {
	empresa: (route: ActivatedRouteSnapshot): Observable<EmpresaResponse> => {
		const id = route.paramMap.get("id") as string;
		const empresaService = inject(EmpresaService);
		return empresaService.getById(id);
	}
}


export const routes: Routes = [ 
	{ path: "", component: ListEmpresaComponent },
	{ 
		path: "editar-empresa/:id", 
		component: EditarEmpresaComponent,
		resolve: ResolverEmpresa
	},
	{ path: "nova-empresa", component: NovaEmpresaComponent }
];
