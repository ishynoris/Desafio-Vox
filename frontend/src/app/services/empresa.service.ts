import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { EmpresaListResponse, EmpresaResponse } from "../interfaces/empresa_response.interface";
import { PayloadEmpresa } from '../interfaces/empresa.interface';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EmpresaService {

	httpClient = inject(HttpClient);
  baseUrlApi = "/api/v1/empresa/";

  getAll(): Observable<EmpresaListResponse> {
    const url = this.baseUrlApi;
    return this.httpClient.get<EmpresaListResponse>(url);
  }

  getById(id: string): Observable<EmpresaResponse> {
    const url = this.baseUrlApi.concat(id);
    return this.httpClient.get<EmpresaResponse>(url);
  }

  atualizar(id: number, empresa: PayloadEmpresa): Observable<EmpresaResponse> {
    const url = this.baseUrlApi + id;
    return this.httpClient.put<EmpresaResponse>(url, empresa);
  }

  salvar(empresa: PayloadEmpresa): Observable<EmpresaResponse> {
    const url = this.baseUrlApi;
    return this.httpClient.post<EmpresaResponse>(url, empresa);
  }

  apagar(id: number): Observable<EmpresaResponse> {
    const url = this.baseUrlApi + id;
    return this.httpClient.delete<EmpresaResponse>(url);
  }
}
