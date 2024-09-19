import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { ClubesService } from '../../../services/clubes.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-create-club',
  templateUrl: './create-club.dialog.component.html',
  styleUrls: ['./create-club.component.css'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule]
})
export class CreateClubComponent {
  clubForm: FormGroup;
  showForm: boolean = false;

  @Output() clubCreated = new EventEmitter<void>();

  constructor(
    private fb: FormBuilder,
    private clubesService: ClubesService
  ) {
    this.clubForm = this.fb.group({
      nombre: ['', Validators.required],
      deporte: ['', Validators.required],
      ubicacion: ['', Validators.required],
      fecha_fundacion: ['', Validators.required]
    });
  }

  toggleForm(): void {
    this.showForm = !this.showForm;
  }

  createClub(): void {
    if (this.clubForm.valid) {
      this.clubesService.createClub(this.clubForm.value).subscribe(response => {
        alert(response.message);
        this.clubCreated.emit();
        this.clubForm.reset();
      });
      this.toggleForm();
    }
  }
}
