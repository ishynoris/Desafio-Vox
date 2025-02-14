import { MetaData } from "./metadata.interface";

export interface Empresa {
	id: number,
	nome: string,
	cnpj: string,
	cnpj_mascara: string,
	data_fundacao: string,
	data_fundacao_ptbr: string,
	data_criacao: string,
	data_criacao_ptbr: string
	data_atualizacao: string
	data_atualizacao_ptbr: string
	meta_data: MetaData;
}

export interface PayloadEmpresa {
	nome: string,
	cnpj: string,
	data_fundacao: string | null
}

export interface EmpresaListResponse {
	total: number,
	message: string,
	data: Array<Empresa>;
}

export interface EmpresaResponse {
	message: string,
	data: Empresa;
}