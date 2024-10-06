import { Empresa } from "./empresa.interface";

export interface EmpresaListResponse {
	total: number,
	message: string,
	data: Array<Empresa>;
}

export interface EmpresaResponse {
	message: string,
	data: Empresa;
}