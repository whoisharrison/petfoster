// pop out sign-up modal

import{Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import {SignUpService} from "../services/sign-up.service";
import {SignUp} from "../classes/sign-up";
declare var $: any;

@Component({
	templateUrl: "./template/sign-up.php",
	selector: "sign-up"
})

export class SignUpComponent implements OnInit{
	@ViewChild("signUpForm") signUpForm : any;
	signUp: SignUp = new SignUp(null, null, null, null);
	status: Status = null;

	constructor(private signUpService: SignUpService, private router: Router){}

	ngOnInit(): void {
	}

	createSignUp() : void {
		this.signUpService.createSignUp(this.signUp)
			.subscribe(status => {
				console.log(this.signUp);
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					alert("Please check your email and click the link to activate your account. Thanks!");
					this.signUpForm.reset();
					setTimeout(function(){$("#signup-modal").modal('hide');},500);
					this.router.navigate([""]);
				}
			});
	}
}