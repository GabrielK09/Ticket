package cnaeapi

import (
	"log"
	"net"
	"os"
	"os/exec"
)

func StartCnaeApi(ip net.IP, path string) error {
	cmd := exec.Command("go", "run", "cmd/api/api.go")
	cmd.Dir = path

	cmd.Stdout = os.Stdout
	cmd.Stderr = os.Stderr

	if err := cmd.Start(); err != nil {
		log.Println("Erro ao iniciar a API do CNAE: ", err)
		return err

	}

	return nil
}
