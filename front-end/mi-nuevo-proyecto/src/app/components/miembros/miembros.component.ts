import { Component, OnInit } from '@angular/core';
import { MembersService } from '../../services/members.service';
import { CommonModule } from '@angular/common';
import { UpdateMiembroComponent } from './update/update-miembro.component';
import { CreateMiembroComponent } from './create/create-miembro.component';

@Component({
  selector: 'app-miembros',
  standalone: true,
  templateUrl: './miembros.component.html',
  styleUrls: ['./miembros.component.css'],
  imports: [CommonModule, UpdateMiembroComponent, CreateMiembroComponent]
})
export class MiembrosComponent implements OnInit {
    miembros: any[] = [];
    selectedMiembro: any = null;
    isModalOpen: boolean = false;

    constructor(private membersService: MembersService) {}

    ngOnInit() {
      this.loadMiembros();
    }

    loadMiembros() {
      this.membersService.getMiembros().subscribe(data => {
        this.miembros = data;
      });
    }

    handleMiembroCreated(): void {
      this.loadMiembros();
    }

    handleMiembroUpdated(): void {
      this.loadMiembros();
    }

    openEditDialog(miembro: any): void {
      this.selectedMiembro = miembro;
      this.isModalOpen = true;
    }

    deleteMiembro(id: number, nombre: string, appelido: string): void {
      if (confirm(`¿Estás seguro de que quieres eliminar al miembro "${nombre} ${appelido}"?`)) {
        this.membersService.deleteMiembro(id).subscribe(() => {
          this.loadMiembros();
        });
      }
    }

    handleCancel(): void {
      this.selectedMiembro = null;
      this.isModalOpen = false; // Cierra el modal
    }

    handleSave(updatedMiembro: any): void {
      this.membersService.updateMiembro(updatedMiembro).subscribe(() => {
        this.loadMiembros();
        this.handleCancel(); // Opcionalmente podrías cerrar el modal aquí si es necesario
      });
    }
}
