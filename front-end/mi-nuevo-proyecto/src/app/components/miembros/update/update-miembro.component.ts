import { Component, Input, Output, EventEmitter, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ClubesService } from '../../../services/clubes.service';
import { MembersService } from '../../../services/members.service';

@Component({
  selector: 'app-edit-miembro-dialog',
  templateUrl: './update-miembro.component.html',
  styleUrls: ['./update-miembro.component.css'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule]
})
export class UpdateMiembroComponent implements OnInit {
  @Input() miembro: any;
  @Output() save = new EventEmitter<any>();
  @Output() cancel = new EventEmitter<void>();
  editForm: FormGroup;
  @Input() isOpen: boolean = false;
  clubes: any[] = [];
  selectedMember: any = null;
  isModalOpen: boolean = false;


  constructor(private fb: FormBuilder, private clubService: ClubesService, private memberService: MembersService) {
    this.editForm = this.fb.group({
      id: [null],
      nombre: ['', Validators.required],
      apellido: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      telefono: ['', [Validators.required, Validators.pattern('^[0-9]{1,10}$')]],
      club_id: ['', Validators.required]
    });
  }
  ngOnInit(): void {
    this.loadClubes();
  }

  loadClubes(): void {
    this.clubService.getClubes().subscribe(data => {
      this.clubes = data;
    });
  }

  ngOnChanges(): void {
    if (this.miembro) {

      this.editForm.patchValue({
        id: this.miembro.id,
        nombre: this.miembro.nombre,
        apellido: this.miembro.apellido,
        email: this.miembro.email,
        telefono: this.miembro.telefono,
        club_id: this.miembro.club_id
      });
    }
  }

  onSave(): void {
    if (this.editForm.valid) {
      this.save.emit(this.editForm.value);
    }
  }

  close(): void {
    this.cancel.emit();
  }

  handleSave(updatedMember: any): void {
    this.memberService.updateMiembro(updatedMember).subscribe(() => {
      this.loadClubes();
      this.handleCancel(); // Opcionalmente podrías cerrar el modal aquí si es necesario
    });
  }

  handleCancel(): void {
    this.selectedMember = null;
    this.isModalOpen = false; // Cierra el modal
  }
}
