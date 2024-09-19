import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { MembersService } from '../../../services/members.service';

@Component({
  selector: 'app-create-miembro',
  templateUrl: './create-miembro.component.html',
  styleUrls: ['./create-miembro.component.css'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule]
})
export class CreateMiembroComponent {
  miembroForm: FormGroup;
  showForm: boolean = false;

  @Output() clubCreated = new EventEmitter<void>();

  constructor(
    private fb: FormBuilder,
    private membersService: MembersService
  ) {
    this.miembroForm = this.fb.group({
      nombre: ['', Validators.required],
      apellido: ['', Validators.required],
      email: ['', Validators.required],
      telefono: ['', Validators.required],
      club: ['', Validators.required]
    });
  }

  toggleForm(): void {
    this.showForm = !this.showForm;
  }

  createMiembro(): void {
    if (this.miembroForm.valid) {
      this.membersService.createMiembro(this.miembroForm.value).subscribe(() => {
        this.clubCreated.emit();
        this.miembroForm.reset();
      });
      this.toggleForm();
    }
  }
}
