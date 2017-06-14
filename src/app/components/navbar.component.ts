import {Component, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";
import {SignUpService} from "../services/sign-up.service";
import {SignUp} from "../classes/sign-up";
import {State} from "../classes/state";
declare var $: any;
@Component({
	selector: "navbar",
	templateUrl: "./templates/navbar.php"
})
// sign in
export class NavBarComponent {
	@ViewChild("signInForm") signInForm : any;
	signInData: SignIn = new SignIn(null, null);
	status: Status = null;
	constructor(private SignInService: SignInService, private SignUpService: SignUpService, private router: Router){}
	createSignIn() : void {
		this.SignInService.postSignIn(this.signInData)
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
	signUp: SignUp = new SignUp(null, null, null, null, null, null, null, null, null, null, null, null, null);
	// minified array of states, messy but saves an API call
	private states : State[] = [{"stateAbbreviation":"AL","stateName":"Alabama"},{"stateAbbreviation":"AK","stateName":"Alaska"},{"stateAbbreviation":"AS","stateName":"American Samoa"},{"stateAbbreviation":"AZ","stateName":"Arizona"},{"stateAbbreviation":"AR","stateName":"Arkansas"},{"stateAbbreviation":"CA","stateName":"California"},{"stateAbbreviation":"CO","stateName":"Colorado"},{"stateAbbreviation":"CT","stateName":"Connecticut"},{"stateAbbreviation":"DE","stateName":"Delaware"},{"stateAbbreviation":"DC","stateName":"District Of Columbia"},{"stateAbbreviation":"FM","stateName":"Federated States Of Micronesia"},{"stateAbbreviation":"FL","stateName":"Florida"},{"stateAbbreviation":"GA","stateName":"Georgia"},{"stateAbbreviation":"GU","stateName":"Guam"},{"stateAbbreviation":"HI","stateName":"Hawaii"},{"stateAbbreviation":"ID","stateName":"Idaho"},{"stateAbbreviation":"IL","stateName":"Illinois"},{"stateAbbreviation":"IN","stateName":"Indiana"},{"stateAbbreviation":"IA","stateName":"Iowa"},{"stateAbbreviation":"KS","stateName":"Kansas"},{"stateAbbreviation":"KY","stateName":"Kentucky"},{"stateAbbreviation":"LA","stateName":"Louisiana"},{"stateAbbreviation":"ME","stateName":"Maine"},{"stateAbbreviation":"MH","stateName":"Marshall Islands"},{"stateAbbreviation":"MD","stateName":"Maryland"},{"stateAbbreviation":"MA","stateName":"Massachusetts"},{"stateAbbreviation":"MI","stateName":"Michigan"},{"stateAbbreviation":"MN","stateName":"Minnesota"},{"stateAbbreviation":"MS","stateName":"Mississippi"},{"stateAbbreviation":"MO","stateName":"Missouri"},{"stateAbbreviation":"MT","stateName":"Montana"},{"stateAbbreviation":"NE","stateName":"Nebraska"},{"stateAbbreviation":"NV","stateName":"Nevada"},{"stateAbbreviation":"NH","stateName":"New Hampshire"},{"stateAbbreviation":"NJ","stateName":"New Jersey"},{"stateAbbreviation":"NM","stateName":"New Mexico"},{"stateAbbreviation":"NY","stateName":"New York"},{"stateAbbreviation":"NC","stateName":"North Carolina"},{"stateAbbreviation":"ND","stateName":"North Dakota"},{"stateAbbreviation":"MP","stateName":"Northern Mariana Islands"},{"stateAbbreviation":"OH","stateName":"Ohio"},{"stateAbbreviation":"OK","stateName":"Oklahoma"},{"stateAbbreviation":"OR","stateName":"Oregon"},{"stateAbbreviation":"PW","stateName":"Palau"},{"stateAbbreviation":"PA","stateName":"Pennsylvania"},{"stateAbbreviation":"PR","stateName":"Puerto Rico"},{"stateAbbreviation":"RI","stateName":"Rhode Island"},{"stateAbbreviation":"SC","stateName":"South Carolina"},{"stateAbbreviation":"SD","stateName":"South Dakota"},{"stateAbbreviation":"TN","stateName":"Tennessee"},{"stateAbbreviation":"TX","stateName":"Texas"},{"stateAbbreviation":"UT","stateName":"Utah"},{"stateAbbreviation":"VT","stateName":"Vermont"},{"stateAbbreviation":"VI","stateName":"Virgin Islands"},{"stateAbbreviation":"VA","stateName":"Virginia"},{"stateAbbreviation":"WA","stateName":"Washington"},{"stateAbbreviation":"WV","stateName":"West Virginia"},{"stateAbbreviation":"WI","stateName":"Wisconsin"},{"stateAbbreviation":"WY","stateName":"Wyoming"}];

	createSignUp() : void {
		this.SignUpService.createSignUp(this.signUp)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					this.signUpForm.reset();
					setTimeout(function(){$("signup-modal").modal('hide');},500);
					this.router.navigate([""]);
				}
			});
	}
}