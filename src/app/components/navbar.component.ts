import{Component, ViewChild, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";
import {SignUp} from "../classes/sign-up";
import {SignUpService} from "../services/sign-up.service";

declare var $: any;

@Component({
	selector: "navbar",
	templateUrl: "./templates/navbar.php"
})

export class NavBarComponent {

	@ViewChild("signInForm") signInForm : any;

	@ViewChild("signUpForm") signUpForm : any;
	signUp: SignUp = new SignUp(null, null, null, null, null, null, null, null, null, null, null, null, null);

	signInData: SignIn = new SignIn("", "");
	status: Status = null;

	constructor(private SignInService: SignInService, private signUpService:SignUpService, private router: Router ){}
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

