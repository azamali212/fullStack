import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AdminLoginComponent } from './admin-login/admin-login.component';
import { AdminRoutingModule } from './admin-routing.module';



@NgModule({
  imports: [
    CommonModule,
    AdminRoutingModule
  ]
})
export class AdminModule { }
