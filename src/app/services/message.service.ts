import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Message} from "../classes/messages";
import {Status} from "../classes/status";

@Injectable()
export class MessageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private messageUrl = "./apis/message/";


	getAllMessages() : Observable<Message[]> {
		return(this.http.get(this.messageUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByMessageId(messageId : number) : Observable<Message> {
		return(this.http.get(this.messageUrl + messageId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByProfileId(profileId : number) : Observable<Message> {
		return(this.http.get(this.messageUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByOrganizationId(organizationId : number) : Observable<Message> {
		return(this.http.get(this.messageUrl + organizationId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByOrganizationProfileId(organizationProfileId : number) : Observable<Message> {
		return(this.http.get(this.messageUrl + organizationProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByMessageProfileId(messageProfileId : number) : Observable<Message> {
		return(this.http.get(this.messageUrl + messageProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByMessageOrganizationId(messageOrganizationId : number) : Observable<Message> {
		return(this.http.get(this.messageUrl + messageOrganizationId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createMessage(message : Message) : Observable<Status> {
		return(this.http.post(this.messageUrl, message)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}

