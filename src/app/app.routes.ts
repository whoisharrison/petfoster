import {RouterModule, Routes} from "@angular/router";

import {HomeComponent} from "./components/home.component";
import {MessageComponent} from "./components/message.component";
import {PostComponent} from "./components/post.component";
import {ProfileComponent} from "./components/profile.component";
import {FileSelectDirective} from "ng2-file-upload";
import {NavBarComponent} from "./components/navbar.component";
import {EnderComponent} from "./components/ender.component";
import {AboutComponent} from "./components/about.component";
import {ResultComponent} from "./components/result.component";
import {SignUpService} from "./services/sign-up.service";
import {SignInService} from "./services/sign-in.service";
import {SignOutService} from "./services/sign-out.service";
import {SignOutComponent} from "./components/sign-out.component";
import {OrganizationService} from "./services/organization.service";

export const allAppComponents = [
	HomeComponent,
	MessageComponent,
	ProfileComponent,
	PostComponent,
	FileSelectDirective,
	NavBarComponent,
	EnderComponent,
	AboutComponent,
	ResultComponent,
	SignOutComponent
];

export const routes: Routes = [
	{path: "profile", component: ProfileComponent},
	{path: "message",component: MessageComponent},
	{path: "post", component: PostComponent},
	{path: "about", component: AboutComponent},
	{path: "result", component: ResultComponent},
	{path: "sign-out", component: SignOutComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [SignUpService, SignInService, SignOutService, OrganizationService];

export const routing = RouterModule.forRoot(routes);