import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-edit-miembro-dialog',
  templateUrl: './update-miembro.component.html',
  styleUrls: ['./update-miembro.component.css'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule]
})
export class UpdateMiembroComponent {
  @Input() miembro: any;
  @Output() save = new EventEmitter<any>();
  @Output() cancel = new EventEmitter<void>();
  editForm: FormGroup;
  @Input() isOpen: boolean = false;

  constructor(private fb: FormBuilder) {
    this.editForm = this.fb.group({
      id: [null],
      nombre: ['', Validators.required],
      apellido: ['', Validators.required],
      email: ['', Validators.required],
      telefono: ['', Validators.required],
      club_id: ['', Validators.required]
    });
  }

  ngOnChanges(): void {
    if (this.miembro) {

      this.editForm.patchValue({
        id: this.miembro.id,
        nombre: this.miembro.nombre,
        deporte: this.miembro.apellido,
        ubicacion: this.miembro.email,
        fecha_fundacion: this.miembro.telefono
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
