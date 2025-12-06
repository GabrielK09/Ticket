package frontEnd

import (
	"log"
	"os"
	"os/exec"
)

func StartFrontEnd(path string) error {
	if err := MoveFile(); err != nil {
		log.Println("Erro ao criar o .env do front end, abortando a operação: ", err)
		return err
	}

	cmd := exec.Command("quasar", "dev")
	cmd.Dir = path
	cmd.Stdout = os.Stdout
	cmd.Stderr = os.Stderr

	if err := cmd.Start(); err != nil {
		log.Println("Erro ao iniciar o front end: ", err)
		return err

	}

	return nil
}
