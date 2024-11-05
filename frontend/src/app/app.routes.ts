import { Routes } from '@angular/router';
import { AdminModule } from './auth/components/Admins/admin.module';

export const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' }, // Example of a default route
  {
    path: 'admin', // Parent path for admin-related routes
    loadChildren: () => import('./auth/components/Admins/admin.module').then(m => AdminModule) // Adjust the path to your AdminModule if you decide to keep it
  },
  // other routes...
];



