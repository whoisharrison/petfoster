import {Component, OnInit} from "@angular/core";
import {Status} from "../classes/status";
import {SignOutService} from "../services/sign-out.service";

@Component({
	templateUrl: "./templates/sign-out.php"
})

export class SignOutComponent implements OnInit{
	status: Status = null;

	constructor(private signOutService:SignOutService){}

	ngOnInit(): void {
		this.signOutService.signOut()
			.subscribe(status => this.status = status);
	}
}