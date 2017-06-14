import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Organization} from "../classes/organization";

@Injectable ()
export class OrganizationService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	// Define the API endpoint
	private organizationUrl = "api/organization/";

	// Call to profile API and grab the organization by its id.
	getAllOrganizations() :Observable<Organization[]> {
		return(this.http.get(this.organizationUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}
