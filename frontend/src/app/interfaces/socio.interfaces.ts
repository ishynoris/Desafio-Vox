import { MetaData } from "./metadata.interface";
import { Empresa } from "./empresa.interface";

export interface Socio {
	id: number,
	empresa_id: number,
	nome: string,
	cpf: string,
	cpf_mascara: string,
	data_vinculo: string,
	data_vinculo_ptbr: string,
	data_criacao: string,
	data_criacao_ptbr: string,
	data_atualizacao: string,
	data_atualizacao_ptbr: string,
	empresa: Empresa,
	meta_data: MetaData;
}

export interface PayloadSocio {
	empresa_id: number,
	nome: string,
	cpf: string,
	data_vinculo: string | null
}

export interface ResponseSocio {
	message: string,
	data: Socio,
}

export interface ResponseListSocio {
	total: number,
	message: string,
	data: Array<Socio>,
}