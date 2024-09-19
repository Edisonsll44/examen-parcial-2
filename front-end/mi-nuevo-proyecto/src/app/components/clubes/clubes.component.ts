import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ClubesService } from '../../services/clubes.service';
import { CreateClubComponent } from './create/create-club.dialog.component';
import { UpdateClubComponent } from './update/update-club.component';

@Component({
  selector: 'app-clubes',
  templateUrl: './clubes.component.html',
  styleUrls: ['./clubes.component.css'],
  standalone: true,
  imports: [CommonModule, CreateClubComponent, UpdateClubComponent]
})
export class ClubesComponent implements OnInit {
  clubes: any[] = [];
  selectedClub: any = null;
  isModalOpen: boolean = false;

  constructor(private clubesService: ClubesService) {}

  ngOnInit() {
    this.loadClubes();
  }

  loadClubes() {
    this.clubesService.getClubes().subscribe(data => {
      console.log(data);
      this.clubes = data;
    });
  }

  handleClubCreated(): void {
    this.loadClubes();
  }

  handleClubUpdated(): void {
    this.loadClubes();
  }

  openEditDialog(club: any): void {
    this.selectedClub = club;
    this.isModalOpen = true; // Abre el modal
  }

  deleteClub(id: number, nombre: string): void {
    if (confirm(`¿Estás seguro de que quieres eliminar el club "${nombre}"?`)) {
      this.clubesService.deleteClub(id).subscribe(() => {
        this.loadClubes();
      });
    }
  }

  handleCancel(): void {
    this.selectedClub = null;
    this.isModalOpen = false; // Cierra el modal
  }

  handleSave(updatedClub: any): void {
    // Implementa la lógica para guardar los cambios del club aquí
    this.clubesService.updateClub(updatedClub).subscribe(() => {
      this.loadClubes();
      this.handleCancel(); // Opcionalmente podrías cerrar el modal aquí si es necesario
    });
  }
}
