import { ActivatedRouteSnapshot, RedirectCommand, RouterStateSnapshot, Routes } from '@angular/router';
import { ListEmpresaComponent } from './components/empresa/list-empresa/list-empresa.component';
import { NovaEmpresaComponent } from './components/empresa/nova-empresa/nova-empresa.component';
import { EditarEmpresaComponent } from './components/empresa/editar-empresa/editar-empresa.component';
import { ListaSocioComponent } from './components/socio/lista-socio/lista-socio.component';
import { NovoSocioComponent } from './components/socio/novo-socio/novo-socio.component';
import { EditarSocioComponent } from './components/socio/editar-socio/editar-socio.component';
import { RouteResolverService } from './services/route-resolver.service';

export const routes: Routes = [ 
	{ path: "", component: ListEmpresaComponent },
	{ 
		path: "empresa/:id", 
		component: EditarEmpresaComponent,
		resolve: { empresa: RouteResolverService.empresa }
	},
	{ path: "nova-empresa", component: NovaEmpresaComponent },
	{ path: "socios", component: ListaSocioComponent },
	{ path: "novo-socio", component: NovoSocioComponent},
	{ 
		path: "socio/:id", 
		component: EditarSocioComponent,
		resolve: { socio: RouteResolverService.socio }
	}
];
