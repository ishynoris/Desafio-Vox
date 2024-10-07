import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { PayloadSocio, ResponseListSocio, ResponseSocio } from '../interfaces/socio.interfaces';

@Injectable({
  providedIn: 'root'
})
export class SocioService {

	httpClient = inject(HttpClient);
  	baseUrlApi = "/api/v1/socio/";

	getAll(): Observable<ResponseListSocio> {
		const url = this.baseUrlApi;
		return this.httpClient.get<ResponseListSocio>(url);
	}

	getById(id: string): Observable<ResponseSocio> {
		const url = this.baseUrlApi.concat(id);
		return this.httpClient.get<ResponseSocio>(url);
	}

	atualizar(id: number, empresa: PayloadSocio): Observable<ResponseSocio> {
		const url = this.baseUrlApi + id;
		return this.httpClient.put<ResponseSocio>(url, empresa);
	}

	salvar(empresa: PayloadSocio): Observable<ResponseSocio> {
		const url = this.baseUrlApi;
		return this.httpClient.post<ResponseSocio>(url, empresa);
	}

	apagar(id: number): Observable<ResponseSocio> {
		const url = this.baseUrlApi + id;
		return this.httpClient.delete<ResponseSocio>(url);
	}
}
