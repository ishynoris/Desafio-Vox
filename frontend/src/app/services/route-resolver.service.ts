import { inject, Injectable } from '@angular/core';
import { ActivatedRouteSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { EmpresaResponse } from '../interfaces/empresa.interface';
import { EmpresaService } from './empresa.service';
import { ResponseSocio } from '../interfaces/socio.interfaces';
import { SocioService } from './socio.service';

export class RouteResolverService {

	static empresa(route: ActivatedRouteSnapshot): Observable<EmpresaResponse> {
		const id = route.paramMap.get("id") as string;
		const empresaService = inject(EmpresaService);
		return empresaService.getById(id);
	}

	static socio(route: ActivatedRouteSnapshot): Observable<ResponseSocio> {
		const id = route.paramMap.get("id") as string;
		const socioService = inject(SocioService);
		return socioService.getById(id);
	}
}
