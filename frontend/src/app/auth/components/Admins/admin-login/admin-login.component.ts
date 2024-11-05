import { Component } from '@angular/core';
import { ButtonComponent } from '../../../../shared/components/button/button.component';
import { InputComponent } from '../../../../shared/components/input/input.component';
import { RouterOutlet } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-admin-login',
  standalone: true,
  imports: [CommonModule,RouterOutlet,ButtonComponent,InputComponent],
  templateUrl: './admin-login.component.html',
  styleUrls: ['./admin-login.component.css']
})
export class AdminLoginComponent {

  heading: string = 'Sign in to your account';
  showForm: boolean = false; // Form visibility toggle
  adminType: string = ''; //


  constructor(private route: ActivatedRoute, private router: Router) {
    this.route.url.subscribe(url => {
      // Check the URL and set the admin type accordingly
      if (url[1]?.path === 'system-admin') {
        this.adminType = 'system-admin';
        this.heading = 'Sign in to System Administrator Account';
        this.showForm = true; // Show form for System Admin
      } else if (url[1]?.path === 'hospital-admin') {
        this.adminType = 'hospital-admin';
        this.heading = 'Sign in to Hospital Administrator Account';
        this.showForm = true; // Show form for Hospital Admin
      } else {
        this.showForm = false; // Default to navigation
      }
    });
  }

  navigateTo(adminType: string) {
    this.router.navigate([`admin/admin-login/${adminType}`]); // Navigate to the appropriate route
  }
}
