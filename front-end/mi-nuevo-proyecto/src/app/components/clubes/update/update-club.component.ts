import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-edit-club-dialog',
  templateUrl: './update-club.component.html',
  styleUrls: ['./update-club.component.css'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule]
})
export class UpdateClubComponent {
  @Input() club: any; // Entrada para el club
  @Output() save = new EventEmitter<any>(); // Evento para guardar
  @Output() cancel = new EventEmitter<void>(); // Evento para cancelar

  editForm: FormGroup;
  @Input() isOpen: boolean = false; // Entrada para manejar la visibilidad del modal

  constructor(private fb: FormBuilder) {
    this.editForm = this.fb.group({
      id: [null],
      nombre: ['', Validators.required],
      deporte: ['', Validators.required],
      ubicacion: ['', Validators.required],
      fecha_fundacion: ['', Validators.required]
    });
  }

  ngOnChanges(): void {
    if (this.club) {

      this.editForm.patchValue({
        id: this.club.id,
        nombre: this.club.nombre,
        deporte: this.club.deporte,
        ubicacion: this.club.ubicacion,
        fecha_fundacion: this.club.fecha_fundacion
      });
    }
  }

  onSave(): void {
    if (this.editForm.valid) {
      console.log(this.editForm.value);
      this.save.emit(this.editForm.value);
    }
  }

  close(): void {
    this.cancel.emit();
  }
}
