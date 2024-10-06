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