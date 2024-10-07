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

  salvar(empresa: PayloadEmpresa): Observable<EmpresaResponse> {
    const url = this.baseUrlApi;
    return this.httpClient.post<EmpresaResponse>(url, empresa);
  }
}
