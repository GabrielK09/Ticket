package backEnd

import (
	"fmt"
	"log"
	"net"
	"os"
	"os/exec"
)

func StartBackEnd(ip net.IP, path string) error {
	ipLine := fmt.Sprintf("--host=%s", ip)

	cmd := exec.Command("php", "artisan", "serve", ipLine)
	cmd.Dir = path
	cmd.Stdout = os.Stdout
	cmd.Stderr = os.Stderr

	if err := cmd.Start(); err != nil {
		log.Println("Erro ao iniciar o back end: ", err)
		return err

	}

	return nil
}
