import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {MessageService} from "../services/message.service";
import {Message} from "../classes/message";
import {Status} from "../classes/status";
import {OrganizationService} from "../services/organization.service";
import {Organization} from "../classes/organization";

@Component({
	templateUrl: "./templates/message.php"
})

export class MessageComponent implements OnInit {

	newMessage : Message = new Message(null, null, null, null, null, null);
	messages : Message[] = [];
	organizations : Organization[] = [];
	status : Status = null;

	constructor(private messageService : MessageService, private organizationService : OrganizationService) {}

	ngOnInit() : void {
		this.getAllMessages();
		this.getAllOrganizations();
	}


	createMessage() : void {
		this.messageService.createMessage(this.newMessage)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.getAllMessages();
				}
			});
	}

	getAllMessages() : void {
		this.messageService.getAllMessages()
			.subscribe(messages => this.messages = messages);
	}

	getAllOrganizations() : void {
		this.organizationService.getAllOrganizations()
			.subscribe(organizations => this.organizations = organizations);
	}

}