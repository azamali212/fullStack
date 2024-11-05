import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { AdminLoginComponent } from './admin-login/admin-login.component';


const routes: Routes = [
  { path: 'admin-login', component: AdminLoginComponent },
  { path: 'admin-login/system-admin', component: AdminLoginComponent }, // Route for System Admin
  { path: 'admin-login/hospital-admin', component: AdminLoginComponent }, // Route for Hospital Admin
  { path: '**', redirectTo: 'admin-login' }
];




@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule]
})
export class AdminRoutingModule { }
