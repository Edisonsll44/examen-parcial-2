import { Routes } from '@angular/router';
import { ClubesComponent } from './components/clubes/clubes.component';
import { MiembrosComponent } from './components/miembros/miembros.component';

export const routes: Routes = [
  { path: 'clubes', component: ClubesComponent },
  { path: 'miembros', component: MiembrosComponent },
  { path: '', redirectTo: '/clubes', pathMatch: 'full' }, // Redirigir a "clubes" por defecto
  { path: '**', redirectTo: '/clubes' } //
];
