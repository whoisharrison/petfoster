import{Component, ViewChild, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";

declare var $: any;

@Component({
	selector: "navbar",
	templateUrl: "./templates/navbar.php"
})

export class NavBarComponent {

	@ViewChild("signInForm") signInForm : any;

	signInData: SignIn = new SignIn("", "");
	status: Status = null;

	constructor(private SignInService: SignInService, private router: Router){}
	isSignedIn = false;

	ngOnChanges (): void{
		this.isSignedIn = this.SignInService.isSignedIn;
	}

	signIn() : void {
		this.SignInService.postSignIn(this.signInData)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate([""]);
					location.reload(true);
					this.signInForm.reset();


					setTimeout(function(){$("#signin-modal").modal('hide');},1000);
				}
			});
	}
}

