import { platformBrowserDynamic } from "@angular/platform-browser-dynamic";
import { AppModule } from "./app/app.module";

// Keep development mode enabled while restoring the project.
console.log("PetFoster: Angular bootstrap starting");

platformBrowserDynamic()
	.bootstrapModule(AppModule)
	.then(() => {
		console.log("PetFoster: Angular bootstrap completed");
	})
	.catch((error: any) => {
		console.error("PetFoster: Angular bootstrap failed", error);
	});
