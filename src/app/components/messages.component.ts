import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {MessageService} from "../services/message.service";
import {Message} from "../classes/messages";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/messages.php"
})

export class MessagesComponent implements OnInit {

	newMessage : Message = new Message(null, null, null, null);
	messages : Message[] = [];
	status : Status = null;

	constructor(private messageService : MessageService) {}

	ngOnInit() : void {
		this.getAllMessages();
	}

	createMessage() : void {
		this.messageService.createMessage(this.newMessage)
			.subscribe(status => this.status = status);
	}

	getAllMessages() : void {
		this.messageService.getAllMessages()
			.subscribe(messages => this.messages = messages);
	}


	//not sure if I need this?
	postMessage() : void {
		this.postMessage.postMessage(this.message).subscribe(status => this.status = status);
	}
}