import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Organization} from "../classes/organization";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class ProfileService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	// Define the API endpoint
	private profileUrl = "api/profile/";

	// Call to Profile API and edit the profile in question.
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put(this.profileUrl + profile.profileId, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	// Call to Profile API, and get a Profile object by id.
	getProfile(id: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to the API to grab an array of profiles based on the user input.
	getProfileByProfileAtHandle(profileAtHandle: string) :Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileAtHandle)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to the profile API, and grab the corresponding profile by its email.
	getProfileByProfileEmail(profileEmail: string) :Observable<Profile> {
		return(this.http.get(this.profileUrl + profileEmail)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to the profile API, and grab the corresponding profile by its name.
	getProfileByProfileName(profileName: string) :Observable<Profile> {
		return(this.http.get(this.profileUrl + profileName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its id.
	getOrganizationByOrganizationId(organizationId: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its city.
	getOrganizationByOrganizationCity(organizationCity: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationCity)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its city.
	getOrganizationByOrganizationEmail(organizationEmail: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationEmail)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its name.
	getOrganizationByOrganizationName(organizationName: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its phone number.
	getOrganizationByOrganizationPhone(organizationPhone: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationPhone)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its state.
	getOrganizationByOrganizationState(organizationState: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationState)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call to profile API and grab the organization by its Zip.
	getOrganizationByOrganizationZip(organizationZip: string) :Observable<Organization> {
		return(this.http.get(this.profileUrl + organizationZip)
			.map(this.extractData)
			.catch(this.handleError));
	}
}