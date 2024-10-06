import { ApplicationConfig, provideZoneChangeDetection } from '@angular/core';
import { provideRouter } from '@angular/router';
import { routes } from './app.routes';
import { provideHttpClient } from '@angular/common/http';
import { provideAnimations } from '@angular/platform-browser/animations';
import { provideNativeDateAdapter } from '@angular/material/core';

export const appConfig: ApplicationConfig = {
  providers: [
	provideZoneChangeDetection({ eventCoalescing: true }), 
	provideAnimations(),
	provideNativeDateAdapter(),
	provideRouter(routes),
	provideHttpClient()
  ]
};
