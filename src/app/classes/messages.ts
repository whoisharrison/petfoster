export class Message {


	constructor(public messageId: number,
					public messageProfileId: number,
					public messageOrganizationId: number,
					public messageContent: string,
					public messageDateTime: Date,
					public messageSubject: string) {}
}







