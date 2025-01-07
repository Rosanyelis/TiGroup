/**
 * App Kanban
 */

"use strict";

(async function () {
    let boards;
    const kanbanSidebar = document.querySelector(".kanban-update-item-sidebar"),
        kanbanWrapper = document.querySelector(".kanban-wrapper"),
        commentEditor = document.querySelector(".comment-editor"),
        kanbanAddNewBoard = document.querySelector(".kanban-add-new-board"),
        kanbanAddNewInput = [].slice.call(document.querySelectorAll(".kanban-add-board-input")),
        kanbanAddBoardBtn = document.querySelector(".kanban-add-board-btn"),
        select2 = $(".select2"), // ! Using jquery vars due to select2 jQuery dependency
        assetsPath = document.querySelector("html").getAttribute("data-base-url"),
        modalCreateTask = new bootstrap.Modal(document.querySelector("#TaskModal")),
        modalCreateBoard = new bootstrap.Modal(document.querySelector("#BoardModal")),
        modalRenameBoard = new bootstrap.Modal(document.querySelector("#RenameBoardModal"));

    // Init kanban Offcanvas
    const kanbanOffcanvas = new bootstrap.Offcanvas(kanbanSidebar);

    // Obtiene la data de la bases de datos de kanban
    const kanbanResponse = await fetch(
        assetsPath + "/kambanjson"
    );
    if (!kanbanResponse.ok) {
        console.error("error", kanbanResponse);
    }
    boards = await kanbanResponse.json();

    //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
    // select2
    if (select2.length) {
        function renderLabels(option) {
            if (!option.id) {
                return option.text;
            }
            var $badge =
                "<div class='badge " +
                $(option.element).data("color") +
                " rounded-pill'> " +
                option.text +
                "</div>";
            return $badge;
        }

        select2.each(function () {
            var $this = $(this);
            select2Focus($this);
            $this.wrap("<div class='position-relative'></div>").select2({
                placeholder: "Seleccione prioridad",
                dropdownParent: $this.parent(),
                templateResult: renderLabels,
                templateSelection: renderLabels,
                escapeMarkup: function (es) {
                    return es;
                },
            });
        });
    }

    // Render board dropdown
    function renderBoardDropdown() {
        return (
            "<div class='dropdown'>" +
            "<i class='dropdown-toggle ri-more-2-line ri-20px cursor-pointer' id='board-dropdown' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></i>" +
            "<div class='dropdown-menu dropdown-menu-end' aria-labelledby='board-dropdown'>"
            + "<a class='dropdown-item add-new-task' href='javascript:void(0)'>"
            + "<i class='ri-add-fill'></i>"
            + "<span class='align-middle'>Nueva Tarea</span>"
            + "</a>"
            + "<a class='dropdown-item rename-board' href='javascript:void(0)'>"
            + "<i class='ri-edit-2-fill'></i>"
            + "<span class='align-middle'>Renombrar Tablero</span>"
            + "</a>"
            + "<a class='dropdown-item delete-board' href='javascript:void(0)'> <i class='ri-delete-bin-7-line text-danger'></i> <span class='align-middle'>Eliminar Tablero</span></a>" +
            "</div>" +
            "</div>"
        );
    }
    // Render item dropdown
    function renderDropdown() {
        return (
            "<div class='dropdown kanban-tasks-item-dropdown'>" +
            "<i class='dropdown-toggle ri-more-2-line' id='kanban-tasks-item-dropdown' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></i>" +
            "<div class='dropdown-menu dropdown-menu-end' aria-labelledby='kanban-tasks-item-dropdown'>" +
            "<a class='dropdown-item delete-task' href='javascript:void(0)'><i class='ri-delete-bin-7-line text-danger'></i> Eliminar Tarea</a>" +
            "</div>" +
            "</div>"
        );
    }
    // Carga el header de la tarjeta de tarea
    function renderHeader(color, text) {
        return (
            "<div class='d-flex justify-content-between flex-wrap align-items-center mb-2'>" +
            "<div class='item-badges d-flex'> " + "</div>" +
            renderDropdown() +
            "</div>"
        );
    }

    // Render avatar
    function renderAvatar(images, pullUp, size, margin, members) {
        var $transition = pullUp ? " pull-up" : "",
            $size = size ? "avatar-" + size + "" : "",
            member = members == undefined ? " " : members.split(",");

        return images == undefined
            ? " "
            : images
                  .split(",")
                  .map(function (img, index, arr) {
                      var $margin =
                          margin && index !== arr.length - 1
                              ? " me-" + margin + ""
                              : "";

                      return (
                          "<div class='avatar " +
                          $size +
                          $margin +
                          "'" +
                          "data-bs-toggle='tooltip' data-bs-placement='top'" +
                          "title='" +
                          member[index] +
                          "'" +
                          ">" +
                          "<img src='" +
                          assetsPath +
                          "img/avatars/" +
                          img +
                          "' alt='Avatar' class='rounded-circle " +
                          $transition +
                          "'>" +
                          "</div>"
                      );
                  })
                  .join(" ");
    }

    // Render footer
    function renderFooter(attachments, comments, assigned, members, color, text) {
        return (
            "<div class='d-flex justify-content-between align-items-center flex-wrap mt-2'>" +
            "<div> <span class='align-middle me-3'><i class='ri-attachment-2 ri-20px me-1'></i>" +
            "<span class='attachments'>" +
            attachments +
            "</span>" +
            "</span> <span class='align-middle'><i class='ri-wechat-line ri-20px me-1'></i>" +
            "<span> " +
            comments +
            " </span>" +
            "</span></div>" +
            "<div class='item-badges d-flex'>" +
            "<div class='badge bg-" + color +"'> " + text +"</div>" +
            "</div>" +
            "</div>"
        );
    }
    // Init kanban
    const kanban = new jKanban({
        element: ".kanban-wrapper",
        gutter: "5px",
        widthBoard: "250px",
        dragItems: true,
        boards: boards,
        dragBoards: true,
        addItemButton: true,
        buttonContent: "+ Add Item",
        itemAddOptions: {
            position: "top",
            enabled: true, // añadir un botón al tablero para facilitar la creación de artículos
            content: "+ Nueva Tarea", // texto o contenido html del botón del tablón
            class: "kanban-title-button btn btn-default btn-md shadow-none text-capitalize fw-normal text-heading", // default class of the button
            footer: false, // posicionar el botón en el pie de página
        },
        click: async function (el) {
            try {
                const element = el;
                const taskId = element.getAttribute("data-eid");

                if (!taskId) {
                    console.error("No se encontró el ID de la tarea.");
                    return;
                }

                // Realizar solicitud GET para obtener los datos de la tarea
                const response = await fetch(`/kamban/${taskId}/show-item`);
                if (!response.ok) {
                    console.error("Error al obtener los datos de la tarea:", response.statusText);
                    return;
                }

                const taskData = await response.json();
                console.log(taskData);

                // Verificar si los datos de la tarea están disponibles
                if (!taskData) {
                    console.error("No se recibieron datos de la tarea.");
                    return;
                }

                // Asignar valores obtenidos a los campos del modal
                document.querySelector("#update_board_id").value = taskData.task.id || "";
                document.querySelector("#title_update").value = taskData.task.title || "";
                document.querySelector("#project_title_update").value = taskData.task.project_title || "";
                document.querySelector("#phone_update").value = taskData.task.phone || "";
                document.querySelector("#email_update").value = taskData.task.email || "";
                document.querySelector("#notes_update").value = taskData.task.notes || "";


                $('#label_update').val(taskData.task.priority).trigger('change');

                // listar los archivos subidos
                const attachments = taskData.files || [];
                const attachmentsHtml = attachments
                    .map(function (attachment) {
                        console.log(attachment.file);

                        return "<li><i class='ri-arrow-drop-right-fill'></i> <a href='" + assetsPath + "" + attachment.file + "' target='_blank'>" + attachment.filename + "</a></li>";
                    })
                    .join("");
                document.querySelector("#archivos_subidos").innerHTML = attachmentsHtml;

                // listar los comentarios
                // const comments = taskData.task.comments || [];
                // const commentsHtml = comments
                //     .map(function (comment) {
                //         return "<p>" + comment + "</p>";
                //     })
                //     .join("");
                // document.querySelector("#comments_update").innerHTML = commentsHtml;


                // Mostrar el modal
                const viewTaskModal = new bootstrap.Modal(document.querySelector("#ViewTaskModal"));
                viewTaskModal.show();
            } catch (error) {
                console.error("Error en la función click:", error);
            }
        },

        buttonClick: function (el, boardId) {
            // abrir modal de crear tarea
            document.querySelector("#modal_board_id").value = boardId;
            modalCreateTask.show();
        },
        dropEl: function (el, target, source, sibling) {
            // Obtener el ID de la tarea y del tablero al que se movió
            const taskId = el.getAttribute("data-eid");
            const newBoardId = target.closest(".kanban-board").getAttribute("data-id");
            // Realizar la solicitud para actualizar el board_id
            fetch('/kamban/move-item-board', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Si usas Laravel
                },
                body: JSON.stringify({
                    task_id: taskId,
                    new_board_id: newBoardId
                })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error al actualizar la tarea");
                }
            })
            .then(data => {
                // console.log("Tarea actualizada con éxito:", data);
            })
            .catch(error => {
                console.error("Error en la actualización:", error);
            });
        },
    });

    // Kanban Wrapper scrollbar
    if (kanbanWrapper) {
        new PerfectScrollbar(kanbanWrapper);
    }

    const kanbanContainer = document.querySelector(".kanban-container"),
        kanbanTitleBoard = [].slice.call(
            document.querySelectorAll(".kanban-title-board")
        ),
        kanbanItem = [].slice.call(document.querySelectorAll(".kanban-item"));

    // Render custom items
    if (kanbanItem) {
        kanbanItem.forEach(function (el) {
            const element = "<span class='kanban-text'>" + el.textContent + "</span>";
            let img = "";
            el.textContent = "";
            if (el.getAttribute("data-image") !== null) {
                img = "<img class='img-fluid mb-2 rounded-4' src='" +assetsPath + "img/elements/" + el.getAttribute("data-image") + "'>";
            }
            if (el.getAttribute("data-badge") !== undefined && el.getAttribute("data-badge-text") !== undefined)
            {
                el.insertAdjacentHTML("afterbegin",
                renderHeader(el.getAttribute("data-badge"), el.getAttribute("data-badge-text")) + img + element);
            }
            if (el.getAttribute("data-comments") !== undefined ||
                el.getAttribute("data-due-date") !== undefined ||
                el.getAttribute("data-assigned") !== undefined)
            {
                el.insertAdjacentHTML(
                    "beforeend",
                    renderFooter(
                        el.getAttribute("data-attachments"),
                        el.getAttribute("data-comments"),
                        el.getAttribute("data-assigned"),
                        el.getAttribute("data-members"),
                        el.getAttribute("data-badge"),
                        el.getAttribute("data-badge-text")

                    )
                );
            }
        });
    }

    // To initialize tooltips for rendered items
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // prevent sidebar to open onclick dropdown buttons of tasks
    const tasksItemDropdown = [].slice.call(
        document.querySelectorAll(".kanban-tasks-item-dropdown")
    );
    if (tasksItemDropdown) {
        tasksItemDropdown.forEach(function (e) {
            e.addEventListener("click", function (el) {
                el.stopPropagation();
            });
        });
    }

    // Crear Tablero
    if (kanbanAddBoardBtn) {
        kanbanAddBoardBtn.addEventListener("click", () => {
            modalCreateBoard.show();
        });
    }

    // Render add new inline with boards
    if (kanbanContainer) {
        kanbanContainer.appendChild(kanbanAddNewBoard);
    }

    // Renombrar tablero
    if (kanbanTitleBoard) {
        kanbanTitleBoard.forEach(function (elem) {
            elem.insertAdjacentHTML("afterend", renderBoardDropdown());
        });
        const renameBoard = [].slice.call(document.querySelectorAll(".rename-board"));
        if (renameBoard) {
            renameBoard.forEach(function (elem) {
                elem.addEventListener("click", function () {
                    const boardId = this.closest(".kanban-board").getAttribute("data-id");
                    // quitar los guiones de titulo y reemplazarlo por espacios
                    // y cada inicial de palabra ponerla en mayuscula
                    const title = this.closest(".kanban-board").querySelector(".kanban-title-board").textContent;
                    const newTitle = title.replace(/-/g, " ").replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
                    console.log(newTitle);
                    document.querySelector("#titleBoard").value = newTitle;
                    document.querySelector("#titleboardid").value = boardId;
                    modalRenameBoard.show();
                });
            });
        }
    }

    // crear tarea con boton del tablero
    const addNewTask = [].slice.call(
        document.querySelectorAll(".add-new-task")
    );
    if (addNewTask) {
        addNewTask.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const boardId = this.closest(".kanban-board").getAttribute("data-id");
                // abrir modal de crear tarea
                document.querySelector("#modal_board_id").value = boardId;
                modalCreateTask.show();
            });
        });
    }
    // Eliminar tarea de tablero
    const deleteTask = [].slice.call(document.querySelectorAll(".delete-task"));
    if (deleteTask) {
        deleteTask.forEach(function (e) {
            e.addEventListener("click", function () {
                const id = this.closest(".kanban-item").getAttribute("data-eid");
                console.log(id)
                Swal.fire({
                    title: '¿Está seguro de eliminar esta Tarea?',
                    text: "No podra recuperar la información!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, eliminar!',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-outline-danger waves-effect'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            "/kamban/"+id+"/delete-item";
                    }
                });
            });
        });
    }

    // Eliminar tablero
    const deleteBoards = [].slice.call(
        document.querySelectorAll(".delete-board")
    );
    if (deleteBoards) {
        deleteBoards.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const id = this.closest(".kanban-board").getAttribute("data-id");
                Swal.fire({
                    title: '¿Está seguro de eliminar este Tablero?',
                    text: "Las tareas del tablero no podran ser recuperadas!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, eliminar!',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-outline-danger waves-effect'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.querySelector("#boardcolumn").value = id;
                        document.querySelector("#form_delete_board").submit();
                    }
                });
            });
        });
    }


    // Clear comment editor on close
    kanbanSidebar.addEventListener("hidden.bs.offcanvas", function () {
        kanbanSidebar.querySelector(".ql-editor").firstElementChild.innerHTML =
            "";
    });

    // Re-init tooltip when offcanvas opens(Bootstrap bug)
    if (kanbanSidebar) {
        kanbanSidebar.addEventListener("shown.bs.offcanvas", function () {
            const tooltipTriggerList = [].slice.call(
                kanbanSidebar.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    }
})();
