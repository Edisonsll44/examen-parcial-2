import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { MembersService } from '../../../services/members.service';
import { ClubesService } from '../../../services/clubes.service';

@Component({
  selector: 'app-create-miembro',
  templateUrl: './create-miembro.component.html',
  styleUrls: ['./create-miembro.component.css'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule]
})

export class CreateMiembroComponent implements OnInit{
  miembroForm: FormGroup;
  showForm: boolean = false;
  clubes: any[] = [];

  @Output() miembroCreated = new EventEmitter<void>();

  constructor(
    private fb: FormBuilder,
    private membersService: MembersService,
    private clubService: ClubesService

  ) {
    this.miembroForm = this.fb.group({
      nombre: ['', Validators.required],
      apellido: ['', Validators.required],
      email: ['', Validators.required],
      telefono: ['', Validators.required],
      club: ['', Validators.required]
    });
  }
  ngOnInit(): void {
    this.loadClubes();
  }
  toggleForm(): void {
    this.showForm = !this.showForm;
  }

  loadClubes(): void {
    this.clubService.getClubes().subscribe(data => {
      this.clubes = data;
    });
  }

  createMiembro(): void {
    if (this.miembroForm.valid) {
      this.membersService.createMiembro(this.miembroForm.value).subscribe(() => {
        this.miembroCreated.emit();
        this.miembroForm.reset();
      });
      this.toggleForm();
    }
  }
}
