import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { EmpresaListResponse } from "../interfaces/empresa_list_response.interface";

@Injectable({
  providedIn: 'root'
})
export class EmpresaService {

	httpClient = inject(HttpClient)

  getAll() {
    return this.httpClient.get<EmpresaListResponse>("/api/v1/empresa");
  }
  constructor() { }
}
