import { Component, ComponentFactoryResolver, ViewChild, ViewContainerRef } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})

export class AppComponent {

  constructor(private router: Router) {}
  navigateToMiembros() {
    this.router.navigate(['/miembros']);
  }

  navigateToClubes() {
    this.router.navigate(['/clubes']);
  }
}
