import {Component, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";
import {SignUpService} from "../services/sign-up.service";
import {Profile} from "../classes/profile";
declare var $: any;
@Component({
	selector: "navbar",
	templateUrl: "./templates/navbar.php"
})
// sign in
export class NavBarComponent {
	@ViewChild("signInForm") signInForm : any;
	signin: SignIn = new SignIn(null, null);
	status: Status = null;
	constructor(private SignInService: SignInService, private SignUpService: SignUpService, private router: Router){}
	signIn() : void {
		this.SignInService.postSignIn(this.signin)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate([""]);
					location.reload(true);
					this.signInForm.reset();
					setTimeout(function(){$("signin-modal").modal('hide');},1000);
				}
			});
	}
	// sign up
	@ViewChild("signUpForm") signUpForm : any;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
	createSignUp() : void {
		this.SignUpService.createSignUp(this.profile)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					alert("Please check your email and click the link to activate your account. Thanks!");
					this.signUpForm.reset();
					setTimeout(function(){$("signup-modal").modal('hide');},500);
					this.router.navigate([""]);
				}
			});
	}
}