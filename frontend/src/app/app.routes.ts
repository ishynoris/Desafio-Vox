import { Routes } from '@angular/router';
import { ListEmpresaComponent } from './components/empresa/list-empresa/list-empresa.component';
import { NovaEmpresaComponent } from './components/empresa/nova-empresa/nova-empresa.component';

export const routes: Routes = [ 
	{ path: "", component: ListEmpresaComponent },
	{ path: "nova-empresa", component: NovaEmpresaComponent }
];
