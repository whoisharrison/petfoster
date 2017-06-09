import {RouterModule, Routes} from "@angular/router";
import {BaconComponent} from "./components/bacon-component";
import {HomeComponent} from "./components/home-component";
import {BaconService} from "./services/ba{

export const allAppComponents = [BaconComponent, HomeComponent, MessagesComponent];

export const routes: Routes = [
	{path: "bacon", component: BaconComponent},
	{path: "", component: HomeComponent},
	{path: "messages",component: MessagesComponent},

];

export const appRoutingProviders: any[] = [BaconService];

// not sure if we needed this? but what the hell, drinking coffee
// export const appRoutingProviders: any[] = [MessageService];

export const routing = RouterModule.forRoot(routes);



//import is acting weird here