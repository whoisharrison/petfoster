export class Message {

	//do i need public Id?
	constructor(public Id : number, public messageId: number, public messageProfileId: number, public messageOrganizationId: number, public messageContent: string, public messageDateTime : DateTime, public messageSubject : string) {}
}











// import {Component, OnInit} from "@angular/core";
// import {ActivatedRoute, Params} from "@angular/router";
// import {Observable} from "rxjs";
// import {MessageService} from "../services/message.service";
// import {Message} from "../classes/message";
// import {Status} from "../classes/status";
//
// @Component({
// 	templateUrl: "./templates/messages.php"
// })
//
// export class MessagesComponent implements OnInit {
//
// 	newMessage : Message = new Message(null, null, null, null);
// 	messages : Message[] = [];
// 	status : Status = null;
//
// 	constructor(private messageService : MessageService) {}
//
// 	ngOnInit() : void {
// 		this.getAllMessages();
// 	}
//
// 	createMessage() : void {
// 		this.messageService.createMessage(this.newMessage)
// 			.subscribe(status => this.status = status);
// 	}
//
// 	getAllMessagess() : void {
// 		this.messageService.getAllMessages()
// 			.subscribe(messages => this.messages = messages);
// 	}
// }