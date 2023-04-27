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
			BX.ajax.runAction('hc:houseceeper.PostType.getTypesInJson')
				.then(responce=>{
				resolve(responce);
			}).catch((error)=>{
				console.log(error);
				reject(error);
			})
		});
	}

}