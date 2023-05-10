import {Type} from 'main.core';

export class HcConstantManager
{
	constructor(options = {name: 'HcConstantManager'})
	{
		this.name = options.name;
	}

	static getPostConstants()
	{
		return new Promise((resolve, reject)=>{
			BX.ajax.runAction('hc:houseceeper.PostType.getTypes')
				.then(responce=>{
				resolve(responce);
			}).catch((error)=>{
				console.log(error);
				reject(error);
			})
		});
	}

	static getPostConstantsRu()
	{
		return new Promise((resolve, reject)=>{
			BX.ajax.runAction('hc:houseceeper.PostType.getTypesRuLang')
				.then(responce=>{
					resolve(responce);
				}).catch((error)=>{
				console.log(error);
				reject(error);
			})
		});
	}

}