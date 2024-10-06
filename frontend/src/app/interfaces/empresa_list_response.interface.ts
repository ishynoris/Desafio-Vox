import { Empresa } from "./empresa.interface";

export interface EmpresaListResponse {
	total: number,
	message: string,
	data: Array<Empresa>;
}